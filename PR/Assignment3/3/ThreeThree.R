setwd('~/Workspace/PR/Assignment3/3/')
library('DiscriMiner')
library('psych')

# read input
data <- read.csv("data1.csv", header = TRUE, sep = ",")
# rearrange data
data <- data[order(data$Class),]
data <- data.matrix(data)
no_of_cols <- ncol(data)

betweenCov1 <- function (variables, group, div_by_n = FALSE) {
  verify_Xy = my_verify1(variables, group, na.rm = FALSE)
  X = verify_Xy$X
  y = verify_Xy$y
  n = nrow(X)
  p = ncol(X)
  glevs = levels(y)
  ng = nlevels(y)
  mean_global = mean(X)
  Between = matrix(0, p, p)
  for (k in 1:ng) {
    tmp <- y == glevs[k]
    nk = sum(tmp)
    mean_k = mean(X[tmp, ])
    dif_k = mean_k - mean_global
    if (div_by_n) {
      between_k = (nk/n) * tcrossprod(dif_k)
    }
    else {
      between_k = (nk/(n - 1)) * tcrossprod(dif_k)
    }
    Between = Between + between_k
  }
  if (is.null(colnames(variables))) {
    var_names = paste("X", 1:ncol(X), sep = "")
    dimnames(Between) = list(var_names, var_names)
  }
  else {
    dimnames(Between) = list(colnames(variables), colnames(variables))
  }
  Between
}

my_verify1 <- function (x, y, qualitative = FALSE, na.rm = na.rm) {
  if (is.null(dim(x))) 
    stop("\n'variables' is not a matrix or data.frame")
  if (!na.rm) {
    if (length(complete.cases(x)) != nrow(x)) 
      stop("\nSorry, no missing values allowed in 'variables'")
  }
  if (nrow(x) != length(y)) 
    stop("\n'variables' and 'group' have different lengths")
  if (!is.vector(y) && !is.factor(y)) 
    stop("\n'group' must be a factor")
  if (!is.factor(y)) 
    y = as.factor(y)
  if (any(!is.finite(y))) 
    stop("\nNo missing values allowed in 'group'")
  if (!qualitative) {
    if (!is.matrix(x)) 
      x <- as.matrix(x)
    if (!is.numeric(x)) 
      stop("\n'variables' must contain only numeric values")
  }
  else {
    fac_check = sapply(x, class)
    if (!is.data.frame(x) && any(fac_check != "factor")) 
      stop("\nA data frame with factors was expected")
  }
  if (is.null(colnames(x))) 
    colnames(x) = paste(rep("X", ncol(x)), seq_len(ncol(x)), 
                        sep = "")
  if (is.null(rownames(x))) 
    rownames(x) = 1L:nrow(x)
  list(X = x, y = y)
}

J1 <- c()
for(x in 1:(no_of_cols-1)){
  Sw <- withinCov(matrix(c(data[,x]), byrow = T, ncol = 1),data[,no_of_cols],div_by_n = T)
  Sb <- betweenCov1(matrix(c(data[,x]), byrow = T, ncol = 1),data[,no_of_cols],div_by_n = T)
  Sm <- Sw + Sb
  J1 <- append(J1,(tr(Sm)/tr(Sw)))
}
selectedClasses <- c(which.max(J1))
corr_coeffs <- c()
classes <- data.matrix(data[,selectedClasses])
colnames(classes)<-colnames(data)[selectedClasses]
classes1 <- data.matrix(data[,-c(selectedClasses,ncol(data))])
colnames(classes1)<-colnames(data)[-c(selectedClasses,ncol(data))]
while(ncol(classes)<2){
  corr_coeffs <- cor(classes, classes1[,1:(ncol(classes1))])
  selectedClasses1 <- which(corr_coeffs<0.8)
  if(length(selectedClasses1)>1){
    classes1 <- classes1[,selectedClasses1]
  } else {
    classes1names<-colnames(classes1)[selectedClasses1]
    classes1 <- data.matrix(classes1[,selectedClasses1])
    colnames(classes1)<-classes1names
  }
  if(ncol(classes1)>0){
    J1<-c()
    for(x in 1:(ncol(classes1))){
      Sw <- withinCov(cbind(classes,classes1[,x]),data[,ncol(data)],div_by_n = T)
      Sb <- betweenCov(cbind(classes,classes1[,x]),data[,ncol(data)],div_by_n = T)
      Sm <- Sw + Sb
      J1 <- append(J1,(tr(Sm)/tr(Sw)))
    }
    selectedClasses <- c(which.max(J1))
    classes<-cbind(classes,classes1[,selectedClasses])
    colnames(classes)<-append(colnames(classes)[-ncol(classes)],colnames(classes1)[selectedClasses])
    classes1names<-colnames(classes1)[-selectedClasses]
    classes1 <- data.matrix(classes1[,-selectedClasses])
    colnames(classes1)<-classes1names
    if(ncol(classes1)==0){
      break
    }
  }else{
    break
  }
}
finalSelected<-colnames(classes)
print("Features selected using forward selection:")
print(finalSelected)
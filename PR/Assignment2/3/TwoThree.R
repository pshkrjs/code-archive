setwd('~/Workspace/PR/Assignment2/3/')
data <- read.csv("./data.csv", header = TRUE, sep = ",")
data <- data[order(data$A),]
alpha <- 0.10
n <- length(data)
dataMean <- mean(data)
frequency <- table(data)
critical_value <- qchisq(alpha, (length(frequency)-1))
cfrequency <- c()
fo <- c()
for(i in 1:nrow(frequency)){
  cfrequency <- append(cfrequency, sum(frequency[1:i]))
  fo <- append(fo, cfrequency[i]/n)
}

values <- dimnames(frequency)
values <- as.numeric(values[[1]])
fe <- pnorm(values, mean = dataMean, sd = sd(data)*(sqrt((n-1)/n))) # normal distribution
X <- qchisq(sum(((fe-fo)^2)/fe), length(frequency)-1)

if(X <= critical_value){
  print("GIVEN DATA FOLLOWS NORMAL DISTRIBUTION")
} else {
  print("GIVEN DATA DOES NOT FOLLOW NORMAL DISTRIBUTION")
}

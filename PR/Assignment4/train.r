setwd('~/Workspace/PR/Assignment4/')
library(dplyr)
library(radiomics)
library(mixAK)
library(EBImage)

paths<-list.files(path="~/Workspace/PR/Assignment4",
                  pattern=".png|.jpg|.JPG",all.files=T, full.names=T, no.. = T,recursive = T)

write.table(t(c("Class","Path")), "training1.csv",row.names = F,
            col.names = F,sep = ",", quote = FALSE)

write.table(t(c(1:83)),"training2.csv",row.names = F, col.names = F, sep = ",", quote = FALSE)

calcFeatures<-function(image)
{
  print(image)
  image_grey<-readImage(image)
  
  dft_feature<-fft(image_grey)/sqrt(nrow(image_grey)*ncol(image_grey))
  
  magnitude<-Mod(dft_feature)
  magnitude<-magnitude[c(1:3,(nrow(magnitude)-2):nrow(magnitude)),c(1:3,(ncol(magnitude)-2):ncol(magnitude)),1]
  #print(length(magnitude))
  
  phase<-Arg(dft_feature)
  phase<-phase[c(1:3,(nrow(phase)-2):nrow(phase)),c(1:3,(ncol(phase)-2):ncol(phase)),1]
  #print(length(phase))
  
  image_grey<-channel(image_grey,"gray")
  image_grey<-image_grey@.Data
  co_mat<-glcm(data = image_grey, angle = 0,d = 1)
  feature<-calc_features(co_mat,features = c("glcm_energy","glcm_entropy","glcm_contrast","glcm_homogeneity2"))
  M00<-M10<-M01<-c(0)
  U00<-U11<-U02<-U20<-U12<-U21<-U03<-U30<-c(0)
  
  #cm<-calcCentroid(image_grey)
  
  #xbar=cm[1]
  #ybar=cm[2]
  for(i in 1:nrow(image_grey))
  {
    for(j in 1:ncol(image_grey))
    {
      M00<-M00+image_grey[i,j]
      M10<-M10+(image_grey[i,j]*i)
      M01<-M01+(image_grey[i,j]*j)
    }
  }
  xbar=M10/M00
  ybar=M01/M00
  #print(xbar)
  #print(ybar)
  for(x in 1:nrow(image_grey))
  {
    for(y in 1:ncol(image_grey))
    {
      U00<-U00+image_grey[x,y]
      U11<-U11+(image_grey[x,y]*(x-xbar)*(y-ybar))
      U02<-U02+(image_grey[x,y]*((y-ybar)^2))
      U20<-U20+(image_grey[x,y]*((x-xbar)^2))
      U12<-U12+(image_grey[x,y]*(x-xbar)*((y-ybar)^2))
      U21<-U21+(image_grey[x,y]*((x-xbar)^2)*(y-ybar))
      U03<-U03+(image_grey[x,y]*((y-ybar)^3))
      U30<-U30+(image_grey[x,y]*((x-xbar)^3))
    }
  }
  
  n11<-U11/(U00^2)
  n02<-U02/(U00^2)
  n20<-U20/(U00^2)
  n12<-U12/(U00^2.5)
  n21<-U21/(U00^2.5)
  n03<-U03/(U00^2.5)
  n30<-U30/(U00^2.5)
  
  phi <- c(
    (n20+n02),
    ((n20-n02)^2)+(4*(n11^2)),
    ((n30-(3*n12))^2)+((n03-(3*n21))^2),
    ((n30+n12)^2)+((n03+n21)^2),
    ((n30-(3*n12))*(n30+n12)*((n30+n12)^2-(3*(n21+n03)^2)))+((n03-(3*n21))*(n03+n21)*((n03+n21)^2-(3*(n12+n30)^2))),
    (n20-n02)*((n30+n12)^2-(n21+n03)^2)+(4*n11*(n30+n12)*(n03+n21)),
    (((3*n21)-n03)*(n30+n12)*((n30+n12)^2-(3*(n21+n03)^2)))+((n30-(3*n12))*(n21+n03)*((n03+n21)^2-(3*(n30+n12)^2)))
  )
  feature<-append(feature,phi)
  feature1<-c()
  for(i in 1:length(feature))
  {
    feature1<-append(feature1,feature[[i]])
  }
  feature1<-append(feature1,c(magnitude,phase))
  print(head(feature1))
  return(feature1)
}

for(img in paths)
{
  write.table(t(c(basename(dirname(img)),img)),"training1.csv",
              row.names = F, col.names = F,sep=',',append = T)
  features<-calcFeatures(img)
  write.table(t(features), "training2.csv", row.names = FALSE, col.names = F,
              sep = ",", quote = FALSE,append = T)
}

training1<-read.csv("training1.csv")
training2<-read.csv("training2.csv")
training<-cbind(training1,training2)
write.csv(training,file = "training.csv")
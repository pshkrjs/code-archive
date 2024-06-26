library(MASS)
library(mixAK)#dMVN

muA <- c(5,10,0)
sigmaA <- matrix(c(1,0,0,0,1,0,0,0,1), ncol = 3, byrow = TRUE)
muB <- c(6,10,2)
sigmaB <- matrix(c(1,0,0,0,1,0,0,0,1), ncol = 3, byrow = TRUE)
muC <- c(4,5,1)
sigmaC <- matrix(c(1,0,0,0,1,0,0,0,1), ncol = 3, byrow = TRUE)

dataA <- mvrnorm(1000, muA, sigmaA, empirical = TRUE)
dataB <- mvrnorm(1000, muB, sigmaB, empirical = TRUE)
dataC <- mvrnorm(1000, muC, sigmaC, empirical = TRUE)

meanA <- colMeans(dataA)
meanB <- colMeans(dataB)
meanC <- colMeans(dataC)

classes <- matrix(c(0), nrow = 3, ncol = 3)

for(i in 1:nrow(dataA)){
  pA <- c(dMVN(dataA[i,], mean = meanA, Sigma = sigmaA), dMVN(dataA[i,], mean = meanB, Sigma = sigmaB), dMVN(dataA[i,], mean = meanC, Sigma = sigmaC))
  pB <- c(dMVN(dataB[i,], mean = meanA, Sigma = sigmaA), dMVN(dataB[i,], mean = meanB, Sigma = sigmaB), dMVN(dataB[i,], mean = meanC, Sigma = sigmaC))
  pC <- c(dMVN(dataC[i,], mean = meanA, Sigma = sigmaA), dMVN(dataC[i,], mean = meanB, Sigma = sigmaB), dMVN(dataC[i,], mean = meanC, Sigma = sigmaC))
  
  classes[1,which.max(pA)] = classes[1,which.max(pA)] + 1
  classes[2,which.max(pB)] = classes[2,which.max(pB)] + 1
  classes[3,which.max(pC)] = classes[3,which.max(pC)] + 1
}
classes
confusionMatrix <- classes/nrow(dataA)
confusionMatrix
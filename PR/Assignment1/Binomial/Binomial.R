data <- read.csv("Data1.csv", header = T, sep = ",")
headsA <- data$A=="H"
headsA <- sum(as.numeric(headsA))
tailsA <- data$A=="T"
tailsA <- sum(as.numeric(tailsA))
probA <- tailsA/(headsA + tailsA)
headsB <- data$B=="H"
headsB <- sum(as.numeric(headsB))
tailsB <- data$B=="T"
tailsB <- sum(as.numeric(tailsB))
probB <- tailsB/(headsB + tailsB)
bA <- dbinom( K <- 0:6, size = 6, prob = probA)
bA
bB <- dbinom( K <- 0:6, size = 6, prob = probB)
bB
a <- 0
b <- 0
D <- c()
E <- c()
for(K in 1:7){
  if( bA[K] > bB[K]){
    D[K] <- c('A')
    E[K] <- bB[K]
    a <- a + E[K]
  } else{
    D[K] <- c("B")
    E[K] <- bA[K]
    b <- b + E[K]
  }
}
matrix( c( 1-b, b, a, 1-a ), nrow = 2, byrow = TRUE, dimnames = list( c('A','B'), c('A','B') ) )
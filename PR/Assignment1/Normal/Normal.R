data <- read.csv("Data2.csv", header = T, sep = ",")
ztable <- read.csv("ztable.csv", header = T, sep = ",")
x <- data$X
y <- data$Y
IN <- c()
AN <- c()
i <- 1
j <- 1
for( K in 1:length(x) ){
  if( y[K] == 'I'){
    IN[i] <- x[K]
    i <- i + 1;
  } else{
    AN[j] <- x[K]
    j <- j + 1;
  }
}
uA <- mean(IN)
uB <- mean(AN)
sA <- var(IN) * (length(IN)-1) / length(IN)
sB <- var(AN) * (length(AN)-1) / length(AN)
sdA <- sqrt(sA)
sdB <- sqrt(sB)
a <- ( sB - sA )
b <- ( 2 * ( uB * sA - uA * sB ) )
c <- ( uA * uA * sB - uB * uB * sA - 2 * sB * sB * logb( sqrt( sB / sA ), base=exp(1) ) )
r1 <- b*b
r1 <- r1 - ( 4 * a * c )
r1 <- sqrt( r1 )
r3 <- r1
r1 <- r1 - b
r2 <- 2 * a
r1 <- r1 / r2
x1 <- r1
r3 <- r3 + b
r3 <- r3 * ( -1 )
r3 <- r3 / r2
x2 <- r3

if( x1 > uA && uB < x1){
  d <- x2
}

if(x2 > uA && uB < x2){
  d <- x1
}
zI <- ( d - uA ) / sdA
zA <- ( d - uB) / sdB
if(zI<0)
  zI <- ( -1 ) * zI
if(zA<0)
  zA <- ( -1 ) * zA
zI
zA
zT <- zI * 100
zT
zT <- ( zT %/% 10 ) / 10
zT
zR <- ( zT * 10 ) + 1
zC <- zI - zT
zC <- zC*1000
zC <- ((zC %/% 10)) + 2 
zC
zR

zI <- ztable[zR, zC]
zI
eI <- 0.5 - zI
eI

zA
zT <- zA * 100
zT
zT <- ( zT %/% 10 ) / 10
zT
zR <- ( zT * 10 ) + 1
zC <- zA - zT
zC <- zC * 1000
zC <- ( ( zC %/% 10 ) ) + 2
zC
zR

zA <- ztable[zR, zC]
zA
eA <- 0.5 - zA
eA
matrix( c(1-eA, eA, eI,1-eI), nrow = 2, byrow = TRUE, dimnames = list(c('A','I'), c('A','I')) )
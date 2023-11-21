sum3cdf<-function(cnt,x)
{
  ycnt = 0
  for(i in 1:cnt)
  {
    z<-(runif(3,min = 0,max = 1))
    m<-(z[1]+z[2]+z[3])
    if(m<=x)
    {
      ycnt=ycnt+1
    }
  }
  return (ycnt/cnt)
}
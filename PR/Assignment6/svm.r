setwd('~/Workspace/PR/Assignment6/')
library(caret)
dataFrame_training<-read.csv(file.choose(), sep = ',', header = FALSE)
intrain <- createDataPartition(y = dataFrame_training$V1, p= 1, list = FALSE)
training <- dataFrame_training[intrain,]

dataFrame_testing<-read.csv(file.choose(), sep = ',', header = FALSE)
intest <- createDataPartition(y = dataFrame_testing$V1, p= 1, list = FALSE)
testing <- dataFrame_testing[intest,]

trctrl <- trainControl(method = "repeatedcv", number = 10, repeats = 3)
svm_Radial <- train(V1 ~., data = training, method = "svmRadial", trControl=trctrl,  preProcess = c("center", "scale"),  tuneLength = 10)
svm_Linear<- train(V1 ~., data = training, method = "svmLinear", trControl=trctrl,  preProcess = c("center", "scale"),  tuneLength = 10)
svm_<- train(V1 ~., data = training, method = "qda", trControl=trctrl,  preProcess = c("center", "scale"),  tuneLength = 10)
test_pred_radial <- predict(svm_Radial, newdata = testing)
test_pred_linear<-predict(svm_Linear, newdata =  testing)
test_pred_quad<-predict(svm_,newdata = testing)

test_pred_linear1<-cbind(dataFrame_testing$V2,levels(test_pred_linear))
test_pred_quad1<-cbind(dataFrame_testing$V2,levels(test_pred_quad))
test_pred_radial1<-cbind(dataFrame_testing$V2,levels(test_pred_radial))
test_pred_linear1
test_pred_quad1
test_pred_radial1

cLinear <- confusionMatrix(test_pred_linear,testing$V1)
cQuad <- confusionMatrix(test_pred_quad,testing$V1)
cRadial <- confusionMatrix(test_pred_radial,testing$V1)

cLinear
cQuad
cRadial
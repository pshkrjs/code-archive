/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package pr_5;

import Jama.Matrix;
import java.io.PrintWriter;
import java.util.List;


public class LMS_Procedure {
    /**
     * @param args the command line arguments
     */
        
    @SuppressWarnings("empty-statement")
    public static void main(String[] args) {
        List<Data> dataSet = CSVReader.take("/home/pshkrjshnde/Workspace/PR/Assignment5/PR_5/src/pr_5/training.csv");

        Matrix At = new Matrix(new double[]{0,-5,0,0,0,0}, 1);
        Matrix b = new Matrix(new double[]{0.2,0.2,0.2,0.2,0.2,0.2}, 1).transpose();
        int i=0,multiplier,iterations =0;
        double theta=0.4;
        double[] val;
        double[][] mat = new double[dataSet.size()][];
        for(Data d : dataSet){
               val = new double[6];
               
            if(d.getLabel().equals("A")){
                multiplier=1;
            }else{
                multiplier=-1;
            }
            val[0]=multiplier*multiplier;
            val[1]=d.getF1()*multiplier;
            val[2]=d.getF2()*multiplier;
            val[3]=d.getF3()*multiplier;
            val[4]=d.getF4()*multiplier;
            val[5]=d.getF5()*multiplier;
            
            System.out.println(val[0]+" "+val[1]+" "+val[2]+" "+val[3]+" "+val[4]+" "+val[5]);
            mat[i]= val;
            i++;
        }
        System.out.println("----------------");
        for(double[] k : mat){            
             System.out.println(k[0]+" "+k[1]+" "+k[2]+" "+k[3]+" "+k[4]+" "+k[5]);
        }
        PrintWriter p = new PrintWriter(System.out, true);
        System.out.println("D");
        System.out.println("--------------------");
       
        Matrix m = new Matrix(mat);
        m.print(new PrintWriter(p,true),1,0);
        
        
        System.out.println("At");
        System.out.println("--------------------");
        
        At.print(new PrintWriter(p,true),1,3);
        System.out.println("A");
        System.out.println("--------------------");
        At.transpose().print(p,1,3); 
        
        
        System.out.println("Result");
        System.out.println("--------------------");
   
        
        
        Matrix result= At.times(new Matrix(m.getArray()[0],1).transpose());
        System.out.println(result.getRowPackedCopy()[0]);
        result.print(new PrintWriter(p,true),1,3);
        System.out.println(result.get(0, 0));
        
        if(verify(At,m,iterations, theta)){
            return;
        }
        boolean again;
                
        int k=0,rows = m.getRowDimension();        
        do{
            again=false;
                Matrix Y = new Matrix(m.getArray()[k],1).transpose();
                for(int j=0;j<Y.getRowDimension();j++){
                    if(Math.abs(Y.times((b.get(j, 0)-At.times(Y).get(0,0))*(1/(k+1))).get(j, 0))>=theta){
                        again=true;
                    }
                       
                }
                if(again){
                    At=updatedA(At.transpose(),Y,k,b).transpose();
                }
                
                k=(k+1)%rows;
                iterations++;
        }while(again);
                
        
        verify(At,m,iterations, theta);

    }
    
    
    public static Matrix updatedA(Matrix A,Matrix Y,double k,Matrix b)
    {
        return A.plusEquals(Y.times((b.get(0, 0)-A.transpose().times(Y).get(0, 0))*1/(k+1)));
    }
    
    public static boolean verify(Matrix At,Matrix Data,int iterations,Double theta){
        int m=Data.getRowDimension();
        for(int i=0;i<m;i++){
             if(At.times(new Matrix(Data.getArray()[i],1).transpose()).get(0, 0)<theta){
                 System.out.println("Misclassified in iterations ="+iterations+"\n with A as :");
                 At.transpose().print(new PrintWriter(System.out,true),1,3);
                 return false;
             }            
        }  
        System.out.println("All are classified ! in iterations = "+iterations+" \n with A as : ");
        At.transpose().print(new PrintWriter(System.out,true),1,3);
        return true;
    }
    
}

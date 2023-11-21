/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package pr_5;

import Jama.Matrix;
import java.io.PrintWriter;
import java.util.List;


public class Ho_Kashyap_Procedure {
       /**
     * @param args the command line arguments
     */
        
    @SuppressWarnings("empty-statement")
    public static void main(String[] args) {
        List<Data> dataSet = CSVReader.take("/home/pshkrjshnde/Workspace/PR/Assignment5/PR_5/src/pr_5/training.csv");

        Matrix At = new Matrix(new double[]{-5,-5,-100,-5,-5,-5}, 1);
        
        int i=0,multiplier,iterations=0,kmax=100000;
        double bmin,theta=0.1;
        double[] val;
        double[] B = new double[dataSet.size()];
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
            B[i]= 0.2;
            i++;
        }
        System.out.println("----------------");
        for(double[] k : mat){            
             System.out.println(k[0]+" "+k[1]+" "+k[2]+" "+k[3]+" "+k[4]+" "+k[5]);
        }
        PrintWriter p = new PrintWriter(System.out, true);
        System.out.println("D");
        System.out.println("--------------------");
       
        Matrix b = new Matrix(B,1).transpose();
        
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
        
        //Calculating bmin
        bmin=b.get(0,0);
        for(i=1;i<b.getRowDimension();i++){
            if(b.get(i, 0)<bmin){
                bmin = b.get(i, 0);
            }            
        }
        bmin=0.1;
        boolean again=false;
        Matrix e,eabs,eplus;
        int k=0,rows = m.getRowDimension();    
        
        if(verify(At,m,b,iterations, bmin)){
            return;
        }
        do{
            again=false;
            e=m.times(At.transpose()).minus(b);
            eabs=e.copy();
            for(i=0;i<e.getRowDimension();i++){
                eabs.set(i, 0, Math.abs(e.get(i, 0)));
            }
            eplus=e.plus(eabs).times(0.5);
            for(int j=0;j<6;j++){
                if(eabs.get(j, 0)>bmin){
                    again=true;
                    break;
                }
            }
            if(again){
                At=updatedA(m,b).transpose();
                b=updatedB(b,k,eplus);
            }
            
            k=(k+1)%rows;
            iterations++;
                
        }while(again && iterations<=kmax);
                
        
        verify(At,m,b,iterations, bmin);

    }
    
    
    public static Matrix updatedA(Matrix Y,Matrix b)
    {
        return Y.inverse().times(b);
    }
    
    public static Matrix updatedB(Matrix b,double k,Matrix eplus)
    {
        return b.plus(eplus.times(2/(k+1)));
    }
    
    public static boolean verify(Matrix At,Matrix Data,Matrix b, int iterations, Double bmin){
        int m=Data.getRowDimension();
        for(int i=0;i<m;i++){
             if(At.times(new Matrix(Data.getArray()[i],1).transpose()).get(0, 0)<=bmin){
                 System.out.println("Misclassified ");
                 System.out.println("in total iterations = "+ iterations+"\n with A as : ");
                 At.transpose().print(new PrintWriter(System.out,true),1,3);
                 
                 return false;
             }            
        }  
        System.out.println("All are classified ! \n with A as : ");
        At.transpose().print(new PrintWriter(System.out,true),1,3);
        System.out.println("in total iterations = "+ iterations);
        System.out.println("and  B as : ");
        b.print(new PrintWriter(System.out,true),1,3);
        return true;
        
    }
    
}

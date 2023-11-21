/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package pr_5;

/**
 *
 * @author pshkrjshnde
 */
class Data { 
    private String label; 
    private double f1; 
    private double f2; 
    private double f3; 
    private double f4; 
    private double f5; 
    public Data(String label, double f1, double f2, double f3, double f4, double f5) { 
        this.label=label;
        this.f1=f1;
        this.f2=f2;
        this.f3=f3;
        this.f4=f4;
        this.f5=f5;
    }  
    public void setF1(double f1) { 
        this.f1 = f1; 
    } 
    public void setF2(double f2) { 
        this.f2 = f2; 
    }
    public void setF3(double f3) { 
        this.f3 = f3; 
    }
    public void setF4(double f4) { 
        this.f4 = f4; 
    }
    public void setF5(double f5) { 
        this.f5 = f5; 
    }
    public String getLabel() { 
        return label; 
    }
    public double getF1() { 
        return f1; 
    } 
    public double getF2() { 
        return f2; 
    }
    public double getF3() { 
        return f3; 
    }
    public double getF4() { 
        return f4; 
    }
    public double getF5() { 
        return f5; 
    }
    
    @Override public String toString() { 
        return "Data [class=" + label + ", f1=" + f1 + ", f2=" + f2 +", f3=" + f3 + ", f4=" + f4 +", f5=" + f5+ "]"; 
    } 
}
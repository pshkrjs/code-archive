package com.company;

public class BBMS {
    public static void main(String[] args) {
        // TODO Auto-generated method stub
        BloodBankMS bbms1=new BloodBankMS();
        BloodBank bb=new BloodBank();
        bb.AddEmployee();
        bb.AddEmployee();
        bb.AddEmployee();
        bb.AddEmployee();
        Receptionist re1=new Receptionist(1,new Name(Title.MR,"Ram","S","Kishen"), new Address("212","Shivaji Road","21",new Pin(411066)));
        Assistant as1=new Assistant(1,new Name(Title.MR,"Raj","M","Datre"), new Address("200","FC Road","12",new Pin(411022)));
        LabTechnician lt1=new LabTechnician(1,new Name(Title.MR,"Rajat","A","Darvare"), new Address("121","MG Road","31",new Pin(411056)));
        Professional p1=new Professional(1,new Name(Title.MR,"Vivek","T","Patel"), new Address("181","Katraj","25",new Pin(411043)));
        System.out.println(re1);
        System.out.println(as1);
        System.out.println(lt1);
        System.out.println(p1);
        }
}

package com.company;

public class Donor {

    static int PId;
    Name name;
    String ph_No;
    char Gender;
    int Age;

    public Donor(int pId, Name name, String ph_No, char gender, int age) {
        PId = pId;
        this.name=name;
        this.ph_No = ph_No;
        Gender = gender;
        Age = age;
    }

    public void donate()
    {
        System.out.println("Donor Donated blood");
    }

    public int getPId()
    {
        return PId;
    }
    public String getPh_No()
    {
        return ph_No;
    }
    public char getGender()
    {
        return Gender;
    }
    public int getAge()
    {
        return Age;
    }
    public void setPId(int pId)
    {
        PId = pId;
    }
    public void setPh_No(String ph_No)
    {
        this.ph_No = ph_No;
    }
    public void setGender(char gender)
    {
        Gender = gender;
    }
    public void setAge(int age)
    {
        Age = age;
    }
}

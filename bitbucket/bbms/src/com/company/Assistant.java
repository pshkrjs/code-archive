package com.company;

public class Assistant extends Employee{

    public Assistant(long id, Name name, Address address) {
        super(id, name, address);
    }

    public void new_register()
    {
        System.out.println("Donor fills registration form");
    }

    public void getinfo(Donor d1, int PId)
    {
        System.out.println(d1);
        System.out.println("The above donor undergoes health exam");
    }

    public String toString()
    {
        StringBuilder builder = new StringBuilder();
        builder.append("Assistant");
        builder.append(super.toString());
        return builder.toString();
    }
}

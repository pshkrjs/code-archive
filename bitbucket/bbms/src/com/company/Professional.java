package com.company;

public class Professional extends Employee{
    public Professional(long id, Name name, Address address) {
        // TODO Auto-generated constructor stub
        super(id, name, address);
    }

    public String toString()
    {
        StringBuilder builder = new StringBuilder();
        builder.append("Professional");
        builder.append(super.toString());
        //builder.append("]");
        return builder.toString();
    }
}

package com.company;

public class CanteenPerson extends Employee{

    public CanteenPerson(long id, Name name, Address address) {
        // TODO Auto-generated constructor stub
        super(id, name, address);
    }

    public void givesRefreshment()
    {
        System.out.println("Canteen Person gives refreshment to the donor");
    }

    public String toString()
    {
        StringBuilder builder = new StringBuilder();
        builder.append("CanteenP");
        builder.append(super.toString());
        return builder.toString();
    }
}

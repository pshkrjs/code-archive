package com.company;

public class Receptionist extends Employee{
    public Receptionist(long id, Name name, Address address) {
        // TODO Auto-generated constructor stub
        super(id, name, address);
    }
    @Override
    public String toString()
    {
        StringBuilder builder = new StringBuilder();
        builder.append("Receptionist");
        builder.append(super.toString());
        return builder.toString();
    }
    public static int availability_of_beds() {
        // TODO Auto-generated method stub
        return 0;
    }
}

package com.company;

public class LabTechnician extends Employee{

    static int no_of_tests;

    public LabTechnician(long id, Name name, Address address) {
        // TODO Auto-generated constructor stub
        super(id, name, address);
    }

    public int test_results()
    {
        return 0;
    }

    public int generateReports()
    {
        while(test_results()==1)
        {
            no_of_tests++;
        }
        return no_of_tests;
    }

    public String toString()
    {
        StringBuilder builder = new StringBuilder();
        builder.append("LabTechnician");
        builder.append(super.toString());
        return builder.toString();
    }
}

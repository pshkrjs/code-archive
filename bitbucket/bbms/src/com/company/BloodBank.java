package com.company;

import java.util.HashMap;
import java.util.Map;
public class BloodBank {
    int m=1;
    public int create_appointment()
    {
        Donor.PId=m++;
        return Donor.PId;
    }
    public int book_bed()
    {
        if(Receptionist.availability_of_beds()>1)
            return 1;
        else
            return 0;
    }
    public void AddEmployee()
    {
        System.out.println("Employee added successfully");
    }
    public void RemoveEmployee()
    {
    }
}

package com.company;

import java.util.Date;
import java.util.List;

public class Person {
    private String personFirstName;
    private String personLastName;
    private int personAge;
    private Date personJoiningDate;
    private List personAppointments;

    public Person(String personFirstName, String personLastName, int personAge, Date personJoiningDate, List personAppointments) {
        this.personFirstName = personFirstName;
        this.personLastName = personLastName;
        this.personAge = personAge;
        this.personJoiningDate = personJoiningDate;
        this.personAppointments = personAppointments;
    }

    public String getPersonFirstName() {
        return personFirstName;
    }

    public void setPersonFirstName(String personFirstName) {
        this.personFirstName = personFirstName;
    }

    public String getPersonLastName() {
        return personLastName;
    }

    public void setPersonLastName(String personLastName) {
        this.personLastName = personLastName;
    }

    public int getPersonAge() {
        return personAge;
    }

    public void setPersonAge(int personAge) {
        this.personAge = personAge;
    }

    public Date getPersonJoiningDate() {
        return personJoiningDate;
    }

    public void setPersonJoiningDate(Date personJoiningDate) {
        this.personJoiningDate = personJoiningDate;
    }

    public List getPersonAppointments() {
        return personAppointments;
    }

    public void setPersonAppointments(List personAppointments) {
        this.personAppointments = personAppointments;
    }
}

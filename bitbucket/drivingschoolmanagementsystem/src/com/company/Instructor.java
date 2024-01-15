package com.company;

import java.util.List;

public class Instructor extends Person {
    private String instructorId;
    private List<Transaction> instructorPayments;

    public Instructor(String instructorId) {
        this.instructorId = instructorId;
    }

    public String getInstructorId() {
        return instructorId;
    }

    public void setInstructorId(String instructorId) {
        this.instructorId = instructorId;
    }

    public List<Transaction> getInstructorPayments() {
        return instructorPayments;
    }

    public void setInstructorPayments(List<Transaction> instructorPayments) {
        this.instructorPayments = instructorPayments;
    }
}

package com.company;

import java.util.List;

public class Customer extends Person {
    private List<Transaction> customerBills;
    private String customerId;

    public Customer(String customerId) {
        this.customerId = customerId;
    }

    public List<Transaction> getCustomerBills() {
        return customerBills;
    }

    public void setCustomerBills(List<Transaction> customerBills) {
        this.customerBills = customerBills;
    }

    public String getCustomerId() {
        return customerId;
    }

    public void setCustomerId(String customerId) {
        this.customerId = customerId;
    }
}

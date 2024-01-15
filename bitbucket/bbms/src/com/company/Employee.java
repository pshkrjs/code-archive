package com.company;

public abstract class Employee {
    private long id;
    private Name name;
    private Address address;

    public Employee(long id, Name name, Address

            address) {
        // TODO Auto-generated constructor stub
        super();
        this.id = id;
        this.name = name;
        this.address = address;
    }

    public long getId() {return id;	}
    private void setId(long id) {this.id = id;}

    public Name getName() {
        return name;
    }

    public void setName(Name name) {
        this.name = name;
    }

    public Address getAddress() {
        return address;
    }

    public void setAddress(Address address) {
        this.address = address;
    }
    @Override
    public String toString() {
        StringBuilder builder = new StringBuilder();
        builder.append("[");
        builder.append(id);
        builder.append(", ");
        builder.append(name);
        builder.append(", ");
        builder.append(address);
        builder.append("]");
        return builder.toString();
    }
}

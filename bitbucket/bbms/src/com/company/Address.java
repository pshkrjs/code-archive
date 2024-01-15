package com.company;

public class Address {
    private String houseNo;
    private String road;
    private String ward;
    private Pin pin;
    public Address(String houseNo, String road, String ward, Pin pin) {
        this.houseNo = houseNo;
        this.road = road;
        this.ward = ward;
        this.pin = pin;
    }
    public String getHouseNo() {return houseNo;	}
    public void setHouseNo(String houseNo) {
        this.houseNo = houseNo;
    }
    public String getRoad() {return road;}
    public void setRoad(String road) {	this.road = road;	}
    public String getWard() {	return ward;
    }
    public void setWard(String ward) {
        this.ward = ward;
    }
    public Pin getPin() {
        return pin;
    }
    public void setPin(Pin pin) {
        this.pin = pin;
    }
    @Override
    public String toString() {
        StringBuilder builder = new StringBuilder();
        //builder.append("[");
        builder.append(houseNo);
        builder.append(", ");
        builder.append(road);
        builder.append(", ");
        builder.append(ward);
        builder.append(", ");
        builder.append(pin);
        //builder.append("]");
        return builder.toString();
    }
}

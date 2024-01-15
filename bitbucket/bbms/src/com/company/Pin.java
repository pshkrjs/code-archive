package com.company;

public class Pin {
    private int pinNumber;
    public Pin(int pinNumber) {
        this.pinNumber = pinNumber;
    }
    public int getPinNumber() {
        return pinNumber;
    }

    private void setPinNumber(int pinNumber) {
        this.pinNumber = pinNumber;
    }
    @Override
    public String toString() {
        StringBuilder builder = new StringBuilder();
        //builder.append("Pin [pinNumber=");
        builder.append(pinNumber);
        //builder.append("]");
        return builder.toString();
    }
}

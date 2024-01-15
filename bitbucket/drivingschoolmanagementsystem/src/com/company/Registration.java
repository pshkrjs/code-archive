package com.company;

public class Registration {
    private int registrationId;
    private Person person;
    private String registrationType;

    public Registration(int registrationId, Person person, String registrationType) {
        this.registrationId = registrationId;
        this.person = person;
        this.registrationType = registrationType;
    }

    public int getRegistrationId() {
        return registrationId;
    }

    public void setRegistrationId(int registrationId) {
        this.registrationId = registrationId;
    }

    public Person getPerson() {
        return person;
    }

    public void setPerson(Person person) {
        this.person = person;
    }

    public String getRegistrationType() {
        return registrationType;
    }

    public void setRegistrationType(String registrationType) {
        this.registrationType = registrationType;
    }
}

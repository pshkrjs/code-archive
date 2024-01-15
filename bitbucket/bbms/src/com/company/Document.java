package com.company;

public class Document {
    public Document() {
        // TODO Auto-generated constructor stub
        super();
    }
    private State state=State.GenReport;
    public void donate()
    {
        if (this.getState().equals(state.GenReport)) {
            System.out.println("Donates Blood");
            setState(State.donate);
        }
    }
    public void refreshmentO()
    {
        if (this.getState().equals(state.donate)) {
            System.out.println("Employee orders refreshment");
            setState(State.orders);
        }
    }

    public void refreshmentR()
    {
        if (this.getState().equals(state.orders)) {
            System.out.println("Donor rejects refreshment");
            setState(State.rejects);
        }
    }
    public void offer()
    {
        if (this.getState().equals(state.rejects)) {
            System.out.println("Donor gets offer");
            setState(State.offera);
        }
    }
    public State getState() {
        return state;
    }
    public void setState(State state) {
        this.state = state;
    }
}

package com.company;

public class Transaction {
    private int TransactionId;
    private float Amount;

    public Transaction(int transactionId, float amount) {
        TransactionId = transactionId;
        Amount = amount;
    }

    public int getTransactionId() {
        return TransactionId;
    }

    public void setTransactionId(int transactionId) {
        TransactionId = transactionId;
    }

    public float getAmount() {
        return Amount;
    }

    public void setAmount(float amount) {
        Amount = amount;
    }
}

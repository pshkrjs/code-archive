package com.company;

import java.util.List;

public class Feedback {
    private int feedbackId;
    private String customerId;
    private List<String> feedbackQuestions;
    private List<String> feedbackAnswers;

    public Feedback(int feedbackId, String customerId, List<String> feedbackQuestions) {
        this.feedbackId = feedbackId;
        this.customerId = customerId;
        this.feedbackQuestions = feedbackQuestions;
    }

    public int getFeedbackId() {
        return feedbackId;
    }

    public void setFeedbackId(int feedbackId) {
        this.feedbackId = feedbackId;
    }

    public String getCustomerId() {
        return customerId;
    }

    public void setCustomerId(String customerId) {
        this.customerId = customerId;
    }

    public List<String> getFeedbackQuestions() {
        return feedbackQuestions;
    }

    public void setFeedbackQuestions(List<String> feedbackQuestions) {
        this.feedbackQuestions = feedbackQuestions;
    }

    public List<String> getFeedbackAnswers() {
        return feedbackAnswers;
    }

    public void setFeedbackAnswers(List<String> feedbackAnswers) {
        this.feedbackAnswers = feedbackAnswers;
    }
}

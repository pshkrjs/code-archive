package college.hinge.interactivestory.models;

/**
 * Created by push on 13/8/16.
 */
public class Choice {
    private String mText;
    private int mNextPageNumber;

    public Choice(String text,int nextPageNumber) {
        mNextPageNumber = nextPageNumber;
        mText = text;
    }

    public String getText() {
        return mText;
    }

    public void setText(String text) {
        mText = text;
    }

    public int getNextPageNumber() {
        return mNextPageNumber;
    }

    public void setNextPageNumber(int nextPageNumber) {
        mNextPageNumber = nextPageNumber;
    }
}

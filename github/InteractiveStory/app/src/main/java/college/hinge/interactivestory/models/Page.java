package college.hinge.interactivestory.models;

/**
 * Created by push on 13/8/16.
 */
public class Page {
    private int mImageResId;
    private String mStoryContent;
    private Choice mChoice1,mChoice2;
    private Boolean isFinal = false;

    public Page(int resId, String content, Choice choice1, Choice choice2) {
        mImageResId = resId;
        mStoryContent = content;
        mChoice1 = choice1;
        mChoice2 = choice2;
    }

    public Page(int imageResId, String storyContent) {
        mImageResId = imageResId;
        mStoryContent = storyContent;
        mChoice1 = null;
        mChoice2 = null;
        isFinal = true;
    }

    public int getImageResId() {
        return mImageResId;
    }

    public void setImageResId(int imageResId) {
        mImageResId = imageResId;
    }

    public String getStoryContent() {
        return mStoryContent;
    }

    public void setStoryContent(String storyContent) {
        mStoryContent = storyContent;
    }

    public Choice getChoice1() {
        return mChoice1;
    }

    public void setChoice1(Choice choice1) {
        mChoice1 = choice1;
    }

    public Choice getChoice2() {
        return mChoice2;
    }

    public void setChoice2(Choice choice2) {
        mChoice2 = choice2;
    }

    public Boolean isFinal(){
        return isFinal;
    }
}

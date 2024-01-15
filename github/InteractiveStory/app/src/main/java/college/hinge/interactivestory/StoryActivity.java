package college.hinge.interactivestory;

import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.TextView;

import college.hinge.interactivestory.models.Page;
import college.hinge.interactivestory.models.Story;

public class StoryActivity extends AppCompatActivity {
    private ImageView mIvStoryImage;
    private TextView mTvStoryContent;
    private Button mBtnChoice1, mBtnChoice2;
    private Story mStory;
    private String name;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_story);

        mIvStoryImage = (ImageView) findViewById(R.id.iv_story_image);
        mTvStoryContent = (TextView) findViewById(R.id.tv_story_content);
        mBtnChoice1 = (Button) findViewById(R.id.btn_choice1);
        mBtnChoice2 = (Button) findViewById(R.id.btn_choice2);

        // load first page
        // set onclick listeners for choices
        // load next page

        mStory = new Story();

        loadPage(0);



        name = getIntent().getStringExtra("key");
        Log.i("StoryActivity", "onCreate: " + name);

    }

    public void loadPage(int pageNumber) {
        final Page currentPage = mStory.getPage(pageNumber);
        mIvStoryImage.setImageResource(currentPage.getImageResId());
        String content = String.format(currentPage.getStoryContent(),name);
        mTvStoryContent.setText(content);

        if (currentPage.isFinal()) {
            mBtnChoice1.setVisibility(View.GONE);
            mBtnChoice2.setText("Play Again");
            mBtnChoice2.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    finish();
                }
            });
        }   else {


            mBtnChoice1.setText(currentPage.getChoice1().getText());
            mBtnChoice2.setText(currentPage.getChoice2().getText());

            mBtnChoice1.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    loadPage(currentPage.getChoice1().getNextPageNumber());
                }
            });

            mBtnChoice2.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {

                    loadPage(currentPage.getChoice2().getNextPageNumber());
                }
            });
        }

    }


}












package college.hinge.interactivestory;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.Toast;

public class MainActivity extends AppCompatActivity {
    private ImageView mIvStory;
    private Button mBtnStart;
    private EditText mEtName;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

        setContentView(R.layout.activity_main);
        mIvStory = (ImageView) findViewById(R.id.iv_story);
        mBtnStart = (Button) findViewById(R.id.btn_start);
        mEtName = (EditText) findViewById(R.id.et_name);

//        1. On Clicking the button fetch the name entered
//        2. Start a new activity
        // 3. Pass the name to next activity

        mBtnStart.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                String name = mEtName.getText().toString();
                Log.i("main", "onClick: " + name);

                Intent intent = new Intent(MainActivity.this,StoryActivity.class);
                intent.putExtra("key",name);
                startActivity(intent);
            }
        });


    }
}

package com.example.push.funfacts;

import android.graphics.Color;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.RelativeLayout;
import android.widget.TextView;

import java.util.Random;

public class FactActivity extends AppCompatActivity {

    // Declare View variables
    private TextView mFactTextView, mFactTitleTextView;
    private Button mNewFactButton;
    private RelativeLayout mRelativeLayout;
    private FactBook mFactBook = new FactBook();
    private ColorWheel mColorWheel = new ColorWheel();

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_fact);

        // Assign view to corresponding variables
        mFactTextView = (TextView) findViewById(R.id.factTextView);
        mFactTitleTextView = (TextView) findViewById(R.id.factTitleTextView);
        mNewFactButton = (Button) findViewById(R.id.newFactButton);
        mRelativeLayout = (RelativeLayout) findViewById(R.id.factRelativeLayout);

        View.OnClickListener updateFact = new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                int randomNumber = mFactBook.getRandomNumber();
                String factTitle = "Fun Fact #" + (randomNumber+1);
                int color = mColorWheel.getColor();

                mFactTextView.setText(mFactBook.getFact(randomNumber));
                mFactTitleTextView.setText(factTitle);
                mRelativeLayout.setBackgroundColor(color);
                mNewFactButton.setTextColor(color);
            }
        };

        mNewFactButton.setOnClickListener(updateFact);
    }
}

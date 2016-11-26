package com.example.pissardo.non;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;


public class Login extends Activity {
    Button button_login,button_close;
    EditText edit_bus_code,edit_password;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);

        button_login = (Button)findViewById(R.id.button);
        edit_bus_code = (EditText)findViewById(R.id.editText);
        edit_password = (EditText)findViewById(R.id.editText2);

        button_close = (Button)findViewById(R.id.button2);

        button_login.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if(edit_bus_code.getText().toString().equals("admin") &&
                        edit_password.getText().toString().equals("admin")) {
                    Toast.makeText(getApplicationContext(),
                            "Localizando...", Toast.LENGTH_LONG).show();
                    callmap();
                }else{
                    Toast.makeText(getApplicationContext(), "Dados Inválidos",Toast.LENGTH_LONG).show();
                }
            }
        });

        button_close.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

                finish();
            }
        });
    }

    private void callmap() {
        startActivity(new Intent(this, MapsActivity.class));
    }

}

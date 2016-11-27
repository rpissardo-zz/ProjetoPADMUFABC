package com.example.pissardo.non;

import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;


public class Login extends Activity {
    SharedPreferences sharedpreferencesPass;
    public static final String MyPREFERENCES = "myprefs";
    public static final  String prefPassword = " ";
    private static final String TAG = "Http Connection";
    Button button_login,button_close;
    EditText edit_bus_code,edit_password;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);
        new MarkerTask().execute();
    }

    public void verifyingAccess(final String username, final String password){
        button_login = (Button)findViewById(R.id.button);
        edit_bus_code = (EditText)findViewById(R.id.editText);
        edit_password = (EditText)findViewById(R.id.editText2);
        button_close = (Button)findViewById(R.id.button2);
        sharedpreferencesPass = getSharedPreferences(MyPREFERENCES, Context.MODE_PRIVATE);
        final String[] j = {sharedpreferencesPass.getString(prefPassword, " ")};
        Log.i(TAG, "*****************************************************");
        Log.i(TAG, j[0]);
        Log.i(TAG, password);
        if(j[0].equals(password)){
            Toast.makeText(getApplicationContext(),
                    "Localizando...", Toast.LENGTH_LONG).show();
         callmap();
        }else {
            button_login.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    if (edit_bus_code.getText().toString().equals(username) &&
                            edit_password.getText().toString().equals(password)) {
                        Toast.makeText(getApplicationContext(),
                                "Localizando...", Toast.LENGTH_LONG).show();
                        SharedPreferences.Editor editorPass = sharedpreferencesPass.edit();
                        editorPass.putString(prefPassword, edit_password.getText().toString());
                        editorPass.commit();
                        j[0] = sharedpreferencesPass.getString(prefPassword, " ");
                        Log.i(TAG, "*****************************************************");
                        Log.i(TAG, j[0]);
                        callmap();
                    } else {
                        Toast.makeText(getApplicationContext(), "Dados Inválidos", Toast.LENGTH_LONG).show();
                    }
                }
            });
        }
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

    private class MarkerTask extends AsyncTask<Void, Void, String> {
        private static final String LOG_TAG = "ExampleApp";
        private static final String SERVICE_URL = "https://fretbus-rpissardo.c9users.io/fretbus/data/map2/1";
        @Override
        protected String doInBackground(Void... args) {
            HttpURLConnection conn = null;
            final StringBuilder json = new StringBuilder();
            try {
                URL url = new URL(SERVICE_URL);
                conn = (HttpURLConnection) url.openConnection();
                InputStreamReader in = new InputStreamReader(conn.getInputStream());
                int read;
                char[] buff = new char[1024];
                while ((read = in.read(buff)) != -1) {
                    json.append(buff, 0, read);
                }
            } catch (IOException e) {
                Log.e(LOG_TAG, "Error connecting to service", e);
            } finally {
                if (conn != null) {
                    conn.disconnect();
                }
            }
            return json.toString();
        }

        @Override
        protected void onPostExecute(String json) {
            try {
                JSONObject jsonObj = new JSONObject(json);
                String username = jsonObj.getString("login");
                String password = jsonObj.getString("password");
                Log.i(TAG, username);
                Log.i(TAG, password);
                verifyingAccess(username,password);
            } catch (JSONException e) {
                Log.e(LOG_TAG, "Error processing JSON", e);
            }

        }
    }


}

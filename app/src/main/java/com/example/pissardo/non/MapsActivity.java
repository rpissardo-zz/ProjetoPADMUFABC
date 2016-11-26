package com.example.pissardo.non;

import android.os.AsyncTask;
import android.os.Bundle;
import android.support.v4.app.FragmentActivity;
import android.util.Log;
import android.widget.CompoundButton;
import android.widget.TextView;
import android.widget.ToggleButton;

import com.google.android.gms.maps.CameraUpdateFactory;
import com.google.android.gms.maps.GoogleMap;
import com.google.android.gms.maps.OnMapReadyCallback;
import com.google.android.gms.maps.SupportMapFragment;
import com.google.android.gms.maps.model.BitmapDescriptorFactory;
import com.google.android.gms.maps.model.LatLng;
import com.google.android.gms.maps.model.MarkerOptions;

import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;
import java.util.Timer;
import java.util.TimerTask;


public class MapsActivity extends FragmentActivity implements OnMapReadyCallback {
    private GoogleMap mMap;
    private static final String TAG = "Http Connection";
    ToggleButton toggle;
    @Override
    public void onCreate(Bundle savedInstanceState) {

        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_maps);
        SupportMapFragment mapFragment = (SupportMapFragment) getSupportFragmentManager()
                .findFragmentById(R.id.map);
        mapFragment.getMapAsync(this);

    }



    @Override
    public void onMapReady(GoogleMap googleMap) {
        mMap = googleMap;
        mMap.setTrafficEnabled(true);
        toggleMap();
    }

    public void toggleMap(){
        toggle = (ToggleButton)findViewById(R.id.toggleButton);
        toggle.setOnCheckedChangeListener(new CompoundButton.OnCheckedChangeListener() {
            public void onCheckedChanged(CompoundButton buttonView, boolean isChecked) {
                if (isChecked) {
                    realTimeMap();
                } else {
                    recordMap();
                }
            }
        });

    }

    public void realTimeMap(){
        new Timer().scheduleAtFixedRate(new TimerTask() {
            @Override
            public void run() {
                new MarkerTask().execute();
            }
        },0,3000);
    }

    public void recordMap(){
        new Timer().scheduleAtFixedRate(new TimerTask() {
            @Override
            public void run() {
                new MarkerTask2().execute();
            }
        },0,3000);
    }

    public void updateCamera(LatLng local){
        mMap.animateCamera(CameraUpdateFactory.newLatLngZoom(local,18));
    }

    public void updateMarker(LatLng local){
        mMap.clear();
        mMap.addMarker(new MarkerOptions().position(local).icon(BitmapDescriptorFactory.fromResource(R.drawable.bus_icon_32)));
    }

    public void updateMarker2(LatLng local){
        mMap.addMarker(new MarkerOptions().position(local).icon(BitmapDescriptorFactory.fromResource(R.drawable.dot)));
    }

    public void updateVelocity(int velocity){
        final TextView textViewToChange = (TextView) findViewById(R.id.velocity);
        textViewToChange.setText("Velocidade do Veículo: " + Integer.toString(velocity)+" Km/h");
    }

    public void updateModifiedAt(String modified){
        final TextView textViewToChange = (TextView) findViewById(R.id.modified);
        textViewToChange.setText("Sem Atualização há: " + modified);
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
            Log.i(TAG, "**********************************************************");
            Log.i(TAG, json.toString());
            return json.toString();
        }

        @Override
        protected void onPostExecute(String json) {
            Log.i(TAG, "*********************************************************");
            Log.i(TAG, String.valueOf(json.length()));
            try {
                // De-serialize the JSON string into an array of city objects
                JSONObject jsonObj = new JSONObject(json);
                Log.i(TAG, "*********************************************************");
                Log.i(TAG, jsonObj.toString());
                LatLng latLng = new LatLng(jsonObj.getDouble("lat"), jsonObj.getDouble("lon"));
                int velocity = jsonObj.getInt("vel");
                String modified = jsonObj.getString("modified");
                Log.i(TAG, "*********************************************************");
                Log.i(TAG, latLng.toString());
                Log.i(TAG, Integer.toString(velocity));
                updateCamera(latLng);
                updateMarker(latLng);
                updateVelocity(velocity);
                updateModifiedAt(modified);
            } catch (JSONException e) {
                Log.e(LOG_TAG, "Error processing JSON", e);
            }

        }
    }


    private class MarkerTask2 extends AsyncTask<Void, Void, String> {
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
            Log.i(TAG, "**********************************************************");
            Log.i(TAG, json.toString());
            return json.toString();
        }

        @Override
        protected void onPostExecute(String json) {
            Log.i(TAG, "*********************************************************");
            Log.i(TAG, String.valueOf(json.length()));
            try {
                // De-serialize the JSON string into an array of city objects
                JSONObject jsonObj = new JSONObject(json);
                Log.i(TAG, "*********************************************************");
                Log.i(TAG, jsonObj.toString());
                LatLng latLng = new LatLng(jsonObj.getDouble("lat"), jsonObj.getDouble("lon"));
                int velocity = jsonObj.getInt("vel");
                String modified = jsonObj.getString("modified");
                Log.i(TAG, "*********************************************************");
                Log.i(TAG, latLng.toString());
                Log.i(TAG, Integer.toString(velocity));
                updateCamera(latLng);
                updateMarker2(latLng);
                updateVelocity(velocity);
                updateModifiedAt(modified);
            } catch (JSONException e) {
                Log.e(LOG_TAG, "Error processing JSON", e);
            }

        }
    }
}

#include "Arduino_LED_Matrix.h";
#include "ArduinoGraphics.h";
#include <WiFiS3.h>;
ArduinoLEDMatrix matrix;

const int Pins[] = {A0};      // Array of Analog Input pins in use (max 4)
const int NumPins = sizeof(Pins) / sizeof(Pins[0]); // Divide total size of Pins[] by Pins[0] to get total number of pins used

const int AirValue = 540;     // Min moisture value (calibrated via open air sensor reading)
const int WaterValue = 345;   // Max moisture value (calibrated via total water submersion sensor reading)
const int MoisturePref = 21;  // Threshold value for watering indicator (percentage)
int moisturePercent;

char ssid[] = "";    // SSID of wifi network
char password[] = "";  // Password of wifi network

void setup() {
  Serial.begin(9600); // opens serial port with data rate set to 9600 bps
  Serial.println("Soil Moisture Sensor Initialized");
  WiFi.begin(ssid, password); // connects to wifi using ssid and password set above
  Serial.println(WiFi.status()); // Prints 3 when connected to a network
}

void loop() {
  
  /*
   * Loop through each pin in use
   * Read current pin value (0 - 1023) and convert to percentage
   * Print current pin value percentage
   */
  for (int i = 0; i < NumPins; i++){
    moisturePercent = map(analogRead(Pins[i]), AirValue, WaterValue, 0, 100);
    Serial.println(moisturePercent);
  }

  delay(2000); // 2 seconds between readings
}

#include "Arduino_LED_Matrix.h";
#include "ArduinoGraphics.h";
#include <WiFi.h>;
ArduinoLEDMatrix matrix;

const int Pins[] = {A0};      // Array of Analog Input pins in use
const int NumPins = sizeof(pins) / sizeof(Pins[0]); // Divide total size of Pins[] by Pins[0] to get total number of pins used

const int AirValue = 540;     // Min moisture value (calibrated via open air sensor reading)
const int WaterValue = 345;   // Max moisture value (calibrated via total water submersion sensor reading)
const int MoisturePref = 21;  // Threshold value for watering indicator (percentage)
int moisturePercent;

char ssid[] = "";    // SSID of wifi network
char password[] = "";  // Password of wifi network

void setup() {
  Serial.begin(9600); // opens serial port with data rate set to 9600 bps
  matrix.begin();
  Serial.println("Soil Moisture Sensor Initialized");
  WiFi.begin(ssid, password); // connects to wifi using ssid and password set above
  Serial.println(WiFi.status()); // Prints WL_CONNECTED when connected to a network
}

/*
 * Frame Setup for each tier of Moisture Level, displays corresponding level in LED matrix
 * "sad" = Moisture Level < 21%: Needs to be watered
 * "happy" = Moisture Level >= 21%: No need to water
 */
const uint32_t sad[] = {
	0x9009,
	0xf01,
	0x8204000
};

const uint32_t happy[] = {
  0x9009,
	0x2041,
	0x80f0000
};

void loop() {
  
  /*
   * Loop through each pin in use
   * Read current pin value (0 - 1023) and convert to percentage
   * Print current pin value percentage
   *
   * Load LED Frame according to moisture percentage
   */
  for (int i = 0; i < NumPins; i++){
    moisturePercent = map(analogRead(Pins[i]), AirValue, WaterValue, 0, 100);
    Serial.println(moisturePercent);

    if (moisturePercent < MoisturePref){
      matrix.loadFrame(sad);
    } else {
      matrix.loadFrame(happy);
    }
  }

  Serial.println(); // After all pins are read, print blank line for readability
  
  /*
   * Code Below here is unnecessary, but may be useful for troubleshooting in the future
   */

  // int sensorRead0 = analogRead(sensor0);
  
  /*
   * Display Moisture Level in Percentage
   */
  // int moisturePercent = map(sensorRead0, AirValue, WaterValue, 0, 100);
  // Serial.print("Moisture Percentage: ");
  // Serial.print(moisturePercent);
  // Serial.println("%");

  /*
   * Display Moisture Level 0 -> 1023 (345 is "dry" -> 540 is "wet")
   */
  // Serial.print("Moisture Level: ");
  // Serial.println(sensorRead0);

  // if (moisturePercent < MoisturePref){
  //   matrix.loadFrame(sad);
  // } else {
  //   matrix.loadFrame(happy);
  // }

  delay(2000); // 2 seconds between readings
}

#include "Arduino_LED_Matrix.h";
ArduinoLEDMatrix matrix;
#define sensorPin1 A0 // Assigns analog in A0 to the first moisture sensor

void setup() {
  Serial.begin(9600); //opens serial port with data rate set to 9600 bps
  matrix.begin();
  Serial.println("Soil Moisture Sensor Initialized");
}

void loop() {
  int sensorValue = analogRead(sensorPin1); 
  int moisturePercent = map(sensorValue, 1024, 0, 0, 100);
  Serial.print("Moisture Level: ");
  Serial.print(moisturePercent);
  Serial.println("%");

  delay(1000);
}

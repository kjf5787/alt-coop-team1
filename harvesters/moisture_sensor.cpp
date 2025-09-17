#define sensorPin1 A0  //replace "A0" with correct input as needed

void readLoop() {
	Serial.print(readSensor(sensorPin1));
	delay(500);
}

int readSensor(sensorPin) {
	int val = analogRead(sensorPin);
	return val;
}

void calibrate(val) {
	int dry = 1000;
	int wet = 300;
	int moisturePercent = map(val, dry, wet, 0, 100);
}

/* 
Need to decide what to do with sensor reads 
Board has integrated WiFi and LED array that can be used
*/
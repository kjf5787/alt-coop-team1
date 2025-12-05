# MoistureSensor.ino
This project uses an Arduino Microcontroller to monitor the soil moisture
levels for plants.  

## Requirements
* Arduino UNO R4 WiFi
* Capacitive moisture sensor probes
* Breadboard (optional)
* Jumper wires (optional)
* Plant in soil
* Arduino IDE

## Wiring
Connect the moisture sensor VCC (red), GRND (black), and OUT wires (yellow)
to the Arduino board in the VCC, GRND, and A0 pins respectively.
**Ensure the wires match, colors may vary by model of sensor!**
A breadboard may ne used in between the sensor and Arduino if preferred.

## To Run
The Pins[] array may be edited to include the Analog Inputs that are being
used on the Arduino microcontroller.  MoisturePref can also be edited to the
preferred moisture level of the plant being used, in general, 21% is a good
minimum moisture level for most plants.

Once loaded onto the Arduino microcontroller via the Arduino IDE, the program
will loop through each pin in Pins[] continuously as long as there is power.
The loop delays 2 seconds between readings.

To utilize WiFi, enter the ssid and password for your network in ssid[]
and password[] respectively.

# MoistureDHTSensor
This project is almost identical to the MoistureSensor.ino project but adds
a digital temperature and humidity sensor.

## Requirements
* Arduino UNO R4 WiFi
* Capacitive moisture sensor probes
* DHT11 Sensor
* Breadboard (optional)
* Jumper wires (optional)
* Plant in soil
* Arduino IDE

## Wiring
Connect the moisture sensor VCC (red), GRND (black), and OUT wires (yellow)
to the Arduino board in the VCC, GRND, and A0 pins respectively.
**Ensure the wires match, colors may vary by model of sensor!**
A breadboard may ne used in between the sensor and Arduino if preferred.
The DHT sensor pins connect signal to D7, VCC to 5V, and GND to GND.

# camera_OV7670.ino
This project is made to run concurrently on a second Arduino Microcontroller 
with the Moisture Sensor.  It includes a camera.  Unlike the moisture sensors, 
1 camera can monitor multiple plants.

## Requirements
* Arduino UNO R4 WiFi
* OV7670 Camera (without FIFO)
* Breadboard
* Jumper wires
* Resistors:
	+ 2x 10k
	+ 1x 1k
	+ 1x 650
* Plant in soil
* Arduino IDE

## Wiring  
Pin Connections:  
OV7670 Camera -> Arduino Uno R4  
 * SIOD (SDA) -> A4 (SDA)
 * SIOC (SCL) -> A5 (SCL)
 * VSYNC -> D2
 * HREF -> D3
 * PCLK -> D4
 * XCLK -> D5 (8MHz PWM)
 * D7 -> D6
 * D6 -> D7
 * D5 -> D8
 * D4 -> D9
 * D3 -> D10
 * D2 -> D11
 * D1 -> D12
 * D0 -> D13
 * 3V3 -> 3.3V
 * GND -> GND
 * RESET -> 3.3V
 * PWDN -> GND  


















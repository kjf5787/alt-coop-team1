# Soil Moisture Sensor
This project uses an Arduino Microcontroller to monitor the soil moisture
levels for plants.  

## Requirements
Arduino UNO R4 WiFi
Capacitive moisture sensor probes
Breadboard (optional)
Jumper wires (optional)
Plant in soil
Arduino IDE

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
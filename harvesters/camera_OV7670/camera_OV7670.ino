#include <Wire.h>

// OV7670 I2C address
#define OV7670_ADDR 0x21

// Pin definitions
#define VSYNC_PIN 2
#define HREF_PIN 3
#define PCLK_PIN 4
#define XCLK_PIN 5

// Data pins (D7-D0)
const int dataPins[8] = {6, 7, 8, 9, 10, 11, 12, 13};

// Image dimensions (QQVGA - smaller to save memory)
#define IMG_WIDTH 160
#define IMG_HEIGHT 120

// Small line buffer instead of full frame
#define LINE_BUFFER_SIZE 160
byte lineBuffer[LINE_BUFFER_SIZE];

// OV7670 register configuration
struct regval {
  uint8_t reg;
  uint8_t val;
};

// QQVGA configuration (160x120)
const struct regval ov7670_qqvga_regs[] = {
  {0x12, 0x80}, // Reset all registers
  {0x11, 0x01}, // CLKRC - prescaler
  {0x12, 0x00}, // COM7 - QVGA + YUV
  {0x0C, 0x04}, // COM3 - DCW enable
  {0x3E, 0x00}, // COM14
  {0x70, 0x3A}, // Scaling XSC
  {0x71, 0x35}, // Scaling YSC
  {0x72, 0x11}, // Scaling DCWCTR
  {0x73, 0xF0}, // Scaling PCLK_DIV
  {0xA2, 0x02}, // Scaling PCLK delay
  {0x15, 0x00}, // COM10 - VSYNC negative
  
  // Color matrix and other settings
  {0x4F, 0x80}, 
  {0x50, 0x80},
  {0x51, 0x00},
  {0x52, 0x22},
  {0x53, 0x5E},
  {0x54, 0x80},
  {0x58, 0x9E},
  
  {0x3A, 0x04}, // TSLB
  {0x14, 0x18}, // COM9 - AGC ceiling
  {0x17, 0x13}, // HSTART
  {0x18, 0x01}, // HSTOP
  {0x32, 0xB6}, // HREF
  {0x19, 0x02}, // VSTART
  {0x1A, 0x7A}, // VSTOP
  {0x03, 0x0A}, // VREF
  
  {0xFF, 0xFF}  // End marker
};

void setup() {
  Serial.begin(115200);
  while (!Serial) delay(10);
  
  Serial.println("OV7670 Camera Initialization");
  Serial.print("Line buffer size: ");
  Serial.print(LINE_BUFFER_SIZE);
  Serial.println(" bytes");
  
  // Initialize I2C
  Wire.begin();
  Wire.setClock(100000);
  
  // Setup XCLK
  setupXCLK();
  
  // Setup control pins
  pinMode(VSYNC_PIN, INPUT);
  pinMode(HREF_PIN, INPUT);
  pinMode(PCLK_PIN, INPUT);
  
  // Setup data pins
  for (int i = 0; i < 8; i++) {
    pinMode(dataPins[i], INPUT);
  }
  
  delay(100);
  
  // Initialize OV7670
  if (!initOV7670()) {
    Serial.println("ERROR: Failed to initialize OV7670!");
    while (1) {
      digitalWrite(LED_BUILTIN, !digitalRead(LED_BUILTIN));
      delay(200);
    }
  }
  
  Serial.println("OV7670 initialized successfully");
  Serial.println();
}

void loop() {
  // Capture a single frame
  captureAndStreamFrame();
  
  delay(2000); // 2 seconds between image captures
}

// Generate 8MHz clock on XCLK pin
void setupXCLK() {
  pinMode(XCLK_PIN, OUTPUT);
  // Generate approximately 8MHz PWM
  analogWrite(XCLK_PIN, 128);
}

// Write to OV7670 register
bool writeReg(uint8_t reg, uint8_t val) {
  Wire.beginTransmission(OV7670_ADDR);
  Wire.write(reg);
  Wire.write(val);
  return (Wire.endTransmission() == 0);
}

// Read from OV7670 register
uint8_t readReg(uint8_t reg) {
  Wire.beginTransmission(OV7670_ADDR);
  Wire.write(reg);
  Wire.endTransmission();
  
  Wire.requestFrom(OV7670_ADDR, 1);
  if (Wire.available()) {
    return Wire.read();
  }
  return 0;
}

// Initialize OV7670
bool initOV7670() {
  // Check if camera responds
  Wire.beginTransmission(OV7670_ADDR);
  if (Wire.endTransmission() != 0) {
    Serial.println("OV7670 not found on I2C bus");
    return false;
  }
  
  Serial.println("OV7670 detected, configuring...");
  
  // Reset camera
  writeReg(0x12, 0x80);
  delay(100);
  
  // Write configuration registers
  int i = 0;
  int success = 0;
  while (ov7670_qqvga_regs[i].reg != 0xFF) {
    if (writeReg(ov7670_qqvga_regs[i].reg, ov7670_qqvga_regs[i].val)) {
      success++;
    } else {
      Serial.print("Warning: Failed to write register 0x");
      Serial.println(ov7670_qqvga_regs[i].reg, HEX);
    }
    delay(1);
    i++;
  }
  
  Serial.print("Configured ");
  Serial.print(success);
  Serial.print("/");
  Serial.print(i);
  Serial.println(" registers");
  
  return (success > 0);
}

// Read byte from parallel data pins
inline uint8_t readByte() {
  uint8_t byte = 0;
  for (int i = 0; i < 8; i++) {
    byte |= (digitalRead(dataPins[i]) << i);
  }
  return byte;
}

// Capture and stream frame line by line
void captureAndStreamFrame() {
  int lineCount = 0;
  int pixelCount = 0;
  
  // Wait for VSYNC to go high (start of frame)
  unsigned long timeout = millis();
  while (digitalRead(VSYNC_PIN) == LOW) {
    if (millis() - timeout > 1000) {
      Serial.println("Timeout waiting for VSYNC high");
      return;
    }
  }
  
  // Wait for VSYNC to go low (active frame)
  timeout = millis();
  while (digitalRead(VSYNC_PIN) == HIGH) {
    if (millis() - timeout > 1000) {
      Serial.println("Timeout waiting for VSYNC low");
      return;
    }
  }
  
  Serial.println("Frame start - streaming data...");
  Serial.println("---BEGIN FRAME---");
  
  // Capture frame line by line
  while (digitalRead(VSYNC_PIN) == LOW && lineCount < IMG_HEIGHT) {
    // Wait for HREF to go high (start of line)
    timeout = millis();
    while (digitalRead(HREF_PIN) == LOW && digitalRead(VSYNC_PIN) == LOW) {
      if (millis() - timeout > 100) break;
    }
    
    if (digitalRead(HREF_PIN) == HIGH) {
      // Capture one line
      int linePixels = 0;
      while (digitalRead(HREF_PIN) == HIGH && linePixels < LINE_BUFFER_SIZE) {
        // Wait for PCLK rising edge
        while (digitalRead(PCLK_PIN) == HIGH && digitalRead(HREF_PIN) == HIGH);
        if (digitalRead(HREF_PIN) == LOW) break;
        while (digitalRead(PCLK_PIN) == LOW && digitalRead(HREF_PIN) == HIGH);
        if (digitalRead(HREF_PIN) == LOW) break;
        
        // Read pixel
        lineBuffer[linePixels++] = readByte();
      }
      
      // Stream line data over serial
      if (linePixels > 0) {
        // Print line number
        Serial.print("L");
        Serial.print(lineCount);
        Serial.print(":");
        
        // Print line data as hex
        for (int i = 0; i < linePixels; i++) {
          if (lineBuffer[i] < 16) Serial.print("0");
          Serial.print(lineBuffer[i], HEX);
          if (i < linePixels - 1) Serial.print(" ");
        }
        Serial.println();
        
        pixelCount += linePixels;
        lineCount++;
      }
    }
  }
  
  Serial.println("---END FRAME---");
  Serial.print("Captured ");
  Serial.print(lineCount);
  Serial.print(" lines, ");
  Serial.print(pixelCount);
  Serial.println(" pixels total");
}
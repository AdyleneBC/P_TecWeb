#include <Arduino.h> // Asegura compatibilidad

// Pines
#define POTENTIOMETER_PIN 36
#define LED_PIN           21

// Configuración del PWM (LEDC)
#define PWM_CHANNEL       0
#define PWM_FREQ_HZ       5000
#define PWM_RESOLUTION_BITS 8

void setup() {
  analogSetAttenuation(ADC_11db);
  
  ledcSetup(PWM_CHANNEL, PWM_FREQ_HZ, PWM_RESOLUTION_BITS);
  ledcAttachPin(LED_PIN, PWM_CHANNEL);
}

void loop() {
  int sensorValue = analogRead(POTENTIOMETER_PIN);
  int brightness = map(sensorValue, 0, 4095, 0, (1 << PWM_RESOLUTION_BITS) - 1);
  ledcWrite(PWM_CHANNEL, brightness);
  delay(10);
}
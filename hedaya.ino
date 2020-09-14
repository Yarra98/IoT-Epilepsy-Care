/**
I found AltSoftSerial more reliable than SoftwareSerial (depends on the version).
https://www.pjrc.com/teensy/td_libs_AltSoftSerial.html

AltSoftSerial pins

Board              Transmit Pin(tx)  Receive Pin(rx) Unusable PWM
Teensy 3.0 & 3.1              21          20           22
Teensy 2.0                    9           10           (none)
Teensy++ 2.0                  25           4           26, 27
Arduino Uno                   9            8           10
Arduino Leonardo              5            13          (none)
Arduino Mega                  46           48          44, 45
Wiring-S                      5            6           4
Sanguino                      13           14          12
*/

#include <Mindwave.h>
#include <SoftwareSerial.h>
#include <AltSoftSerial.h>
SoftwareSerial BT(48, 46);//rx,tx

AltSoftSerial bluetooth;
Mindwave mindwave;
int* eeg;
void setup() {
  BT.begin(38400);
  Serial.begin(57600);
  bluetooth.begin(MINDWAVE_BAUDRATE);
}
void onMindwaveData(){
     eeg = mindwave.eeg();
     
  //for(int i = 0 ; i < MINDWAVE_EEG_SIZE; i++){
    Serial.print(eeg[6]);
   // if(i < MINDWAVE_EEG_SIZE) Serial.print('\t');
  //}

  Serial.println();

}
void loop() {
  if ( BT.available() ) {
    Serial.write( BT.read() );
  }

  if ( Serial.available() ) {
    BT.write( Serial.read() );
  }
  mindwave.update(bluetooth,onMindwaveData);
}

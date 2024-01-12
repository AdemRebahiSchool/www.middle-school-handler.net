import sys
from PyQt5.QtWidgets import QApplication, QWidget, QLabel, QVBoxLayout, QPushButton, QLineEdit, QComboBox, QShortcut
from PyQt5.QtGui import QKeySequence
from PyQt5.QtCore import Qt, QTimer
from pynput.mouse import Button, Controller
from pynput.keyboard import Listener, Key


class AutoClickerApp(QWidget):
    def __init__(self):
        super().__init__()

        self.init_ui()

        self.click_timer = QTimer(self)
        self.click_timer.timeout.connect(self.perform_click)

        self.keyboard_listener = None
        self.setting_key = False
        self.selected_key = None

    def init_ui(self):
        self.setWindowTitle("Auto Clicker")
        self.setGeometry(100, 100, 400, 200)

        layout = QVBoxLayout()

        self.start_button = QPushButton("Start Auto Click")
        self.start_button.clicked.connect(self.start_auto_click)
        layout.addWidget(self.start_button)

        self.end_button = QPushButton("Stop Auto Click")
        self.end_button.clicked.connect(self.stop_auto_click)
        layout.addWidget(self.end_button)

        layout.addWidget(QLabel("Click Cooldown (seconds):"))
        self.cooldown_input = QLineEdit(self)
        layout.addWidget(self.cooldown_input)

        layout.addWidget(QLabel("Number of Clicks (Type 'inf' for infinite):"))
        self.click_count_input = QLineEdit(self)
        layout.addWidget(self.click_count_input)

        layout.addWidget(QLabel("Start/Stop Key:"))

        self.start_stop_key_input = QPushButton("Click to Set Key")
        self.start_stop_key_input.clicked.connect(self.set_start_stop_key)
        layout.addWidget(self.start_stop_key_input)

        self.setLayout(layout)

    def start_auto_click(self):
        cooldown = int(float(self.cooldown_input.text()) * 1000)  # Convert seconds to milliseconds
        click_count = float('inf') if self.click_count_input.text().lower() == 'inf' else int(self.click_count_input.text())

        if self.selected_key:
            self.click_timer.start(cooldown)

            def on_press(key):
                if key == self.selected_key:
                    self.click_timer.stop()

            def on_release(key):
                pass

        self.keyboard_listener = Listener(on_press=on_press, on_release=on_release)
        self.keyboard_listener.start()


    def stop_auto_click(self):
        self.click_timer.stop()
        if self.keyboard_listener:
            self.keyboard_listener.stop()

    def set_start_stop_key(self):
        self.setting_key = True
        self.start_stop_key_input.setText("Press Key (Esc to cancel)")
        shortcut = QShortcut(QKeySequence("Esc"), self)
        shortcut.activated.connect(self.cancel_key_setting)
        shortcut = QShortcut(QKeySequence("Ctrl+Q"), self)
        shortcut.activated.connect(self.cancel_key_setting)
        shortcut = QShortcut(QKeySequence("Enter"), self)
        shortcut.activated.connect(self.confirm_key_setting)

    def cancel_key_setting(self):
        self.setting_key = False
        self.start_stop_key_input.setText("Click to Set Key")

    def confirm_key_setting(self):
        self.setting_key = False
        self.start_stop_key_input.setText(f"Key: {self.selected_key}")

    def keyPressEvent(self, event):
        if self.setting_key and event.key() != Qt.Key_Escape:
            self.selected_key = event.key()


    def perform_click(self):
        mouse = Controller()
        mouse.click(Button.left)

if __name__ == '__main__':
    app = QApplication(sys.argv)
    auto_clicker = AutoClickerApp()
    auto_clicker.show()
    sys.exit(app.exec_())

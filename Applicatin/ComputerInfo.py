import sys
from PyQt5.QtWidgets import QApplication, QMainWindow, QTabWidget, QWidget, QLabel, QSlider, QVBoxLayout, QPushButton, QDialog, QRadioButton, QGroupBox, QVBoxLayout, QHBoxLayout
import subprocess

class SystemInfoApp(QMainWindow):
    def __init__(self):
        super().__init__()
        self.setWindowTitle("System Info App")

        self.create_tabs()

    def create_tabs(self):
        tab_parent = QTabWidget(self)

        basic_settings_tab = QWidget()
        advanced_info_tab = QWidget()
        edit_settings_tab = QWidget()

        tab_parent.addTab(basic_settings_tab, "Basic Settings")
        tab_parent.addTab(advanced_info_tab, "Advanced Information")
        tab_parent.addTab(edit_settings_tab, "Edit Settings")

        self.create_basic_settings_tab(basic_settings_tab)
        self.create_advanced_info_tab(advanced_info_tab)
        self.create_edit_settings_tab(edit_settings_tab)

        self.setCentralWidget(tab_parent)

    def create_basic_settings_tab(self, tab):
        user_label = QLabel("Username:")
        sound_label = QLabel("Sound:")
        luminosity_label = QLabel("Luminosity:")
        keyboard_label = QLabel("Keyboard Language:")

        sound_slider = QSlider()
        sound_slider.setOrientation(1)  # Set slider orientation to vertical
        sound_slider.setMinimum(0)
        sound_slider.setMaximum(100)
        sound_slider.setObjectName("SoundSlider")  # Set the object name
        sound_percentage_label = QLabel("")

        luminosity_slider = QSlider()
        luminosity_slider.setOrientation(1)  # Set slider orientation to vertical
        luminosity_slider.setMinimum(0)
        luminosity_slider.setMaximum(100)
        luminosity_slider.setObjectName("LuminositySlider")  # Set the object name
        luminosity_percentage_label = QLabel("")

        keyboard_button = QPushButton("Choose Keyboard Language")
        keyboard_button.clicked.connect(self.show_keyboard_language_window)

        save_button = QPushButton("Save Settings")
        save_button.clicked.connect(self.save_settings)

        layout = QVBoxLayout()
        layout.addWidget(user_label)
        layout.addWidget(sound_label)
        layout.addWidget(sound_slider)
        layout.addWidget(sound_percentage_label)
        layout.addWidget(luminosity_label)
        layout.addWidget(luminosity_slider)
        layout.addWidget(luminosity_percentage_label)
        layout.addWidget(keyboard_label)
        layout.addWidget(keyboard_button)
        layout.addWidget(save_button)

        tab.setLayout(layout)

    def create_advanced_info_tab(self, tab):
        ip_label = QLabel("IP Information:")
        battery_label = QLabel("Battery Information:")
        disk_label = QLabel("Disk Information:")

        layout = QVBoxLayout()
        layout.addWidget(ip_label)
        layout.addWidget(battery_label)
        layout.addWidget(disk_label)

        tab.setLayout(layout)

    def create_edit_settings_tab(self, tab):
        pass  # Removed Wi-Fi settings

    def save_settings(self):
        # Retrieve sound and luminosity values from sliders
        sound_value = self.centralWidget().currentWidget().findChild(QSlider, "SoundSlider").value()
        luminosity_value = self.centralWidget().currentWidget().findChild(QSlider, "LuminositySlider").value()

        # Apply sound settings using 'osascript' on macOS
        subprocess.run(["osascript", "-e", f"set volume output volume {sound_value}"])

        # Apply luminosity settings using 'brightness' tool (install it using `brew install brightness`)
        subprocess.run(["brightness", f"{luminosity_value / 100}"])

        print("Settings applied")

    def show_keyboard_language_window(self):
        try:
            keyboard_layout = subprocess.check_output(["defaults", "read", "-g", "AppleKeyboardLayout"]).decode("utf-8").strip()
        except subprocess.CalledProcessError:
            # Handle the case when the key does not exist
            keyboard_layout = ""

        keyboard_window = QDialog(self)
        keyboard_window.setWindowTitle("Keyboard Language Selection")

        radio_group = QGroupBox("Select Keyboard Language:")
        radio_layout = QVBoxLayout()

        # Fetch available keyboard layouts
        try:
            available_layouts = subprocess.check_output(["defaults", "read", "/Library/Preferences/com.apple.HIToolbox.plist", "AppleEnabledInputSources"]).decode("utf-8")
            available_layouts = available_layouts.split("\n")[1:-1]  # Remove the first and last empty lines
        except subprocess.CalledProcessError:
            # Handle the case when the key does not exist
            available_layouts = []

        # You can add more languages as needed
        for layout in available_layouts:
            layout_name = layout.split(" ")[-1].replace('"', '')
            radio_button = QRadioButton(layout_name)
            radio_layout.addWidget(radio_button)

            # Set the current layout as checked
            if layout_name == keyboard_layout:
                radio_button.setChecked(True)

        radio_group.setLayout(radio_layout)

        ok_button = QPushButton("OK")
        ok_button.clicked.connect(keyboard_window.accept)

        cancel_button = QPushButton("Cancel")
        cancel_button.clicked.connect(keyboard_window.reject)

        button_layout = QHBoxLayout()
        button_layout.addWidget(ok_button)
        button_layout.addWidget(cancel_button)

        main_layout = QVBoxLayout()
        main_layout.addWidget(radio_group)
        main_layout.addLayout(button_layout)

        keyboard_window.setLayout(main_layout)

        result = keyboard_window.exec_()

        # Use the default value (None) if no radio button is checked
        selected_language = next((radio_button.text() for radio_button in radio_layout.findChildren(QRadioButton) if radio_button.isChecked()), None)

        if result == QDialog.Accepted and selected_language is not None:
            # Set the selected keyboard layout using 'defaults' command
            subprocess.run(["defaults", "write", "-g", "AppleKeyboardLayout", selected_language])
            print(f"Selected Keyboard Layout: {selected_language}")

if __name__ == "__main__":
    app = QApplication(sys.argv)
    window = SystemInfoApp()
    window.show()
    sys.exit(app.exec_())

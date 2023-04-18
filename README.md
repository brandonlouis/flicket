# Setting up to run on localhost [127.0.0.1:5000](127.0.0.1:5000)
You could also refer to [this link](https://youtu.be/6M3LzGmIAso?t=101) for steps 1. and 2.

### 1. Creating and entering Virtual Environment mode
- Traverse into "/flicket" directory in terminal
- Type `python -m venv venv`
- Type `.\venv\Scripts\activate` (Command line should now indicate "(venv)" before the directory)

### 2. Selecting Python interpreter
- In VSC, `Ctrl+Shift+P` to enter Command Palette
- Click "Python: Select Interpreter" 
- Select the option with path ".\venv\Scripts\python.exe", or manually traverse to it

### 3. Installing all necessary libraries
- While in venv mode, type `pip install -r requirements.txt`

### 4. Running the app
- In VSC, open "main.py"
- On the top right, click the "Play" icon. Alternatively, `Ctrl+Alt+N`
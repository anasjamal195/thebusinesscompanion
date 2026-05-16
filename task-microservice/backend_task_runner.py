import os
import subprocess
import threading
from flask import Flask, request, jsonify

app = Flask(__name__)

def run_task(task_id):
    print(f"[{task_id}] Thread started. Running artisan command.")
    try:
        # The script is in task-microservice/, Laravel is in the parent directory
        laravel_dir = os.path.abspath(os.path.join(os.path.dirname(__file__), '..'))
        
        result = subprocess.run(
            ["php", "artisan", "task:process", str(task_id)],
            cwd=laravel_dir,
            capture_output=True,
            text=True
        )
        print(f"[{task_id}] Artisan output: {result.stdout}")
        if result.stderr:
            print(f"[{task_id}] Artisan error: {result.stderr}")
    except Exception as e:
        print(f"[{task_id}] Process exception: {e}")
    print(f"[{task_id}] Thread finished.")

@app.route('/process-task', methods=['POST'])
def process_task():
    data = request.json
    task_id = data.get('task_id')

    if not task_id:
        return jsonify({'error': 'task_id required'}), 400

    thread = threading.Thread(target=run_task, args=(task_id,))
    thread.daemon = True
    thread.start()

    return jsonify({'message': 'Task processing initiated', 'task_id': task_id}), 200

if __name__ == '__main__':
    port = int(os.environ.get('PORT', 5002))
    app.run(host='0.0.0.0', port=port)

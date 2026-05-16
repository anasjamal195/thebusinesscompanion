import os
import requests
import threading
import time
from flask import Flask, request, jsonify

app = Flask(__name__)

def run_task(task_id, webhook_url):
    print(f"[{task_id}] Thread started. Calling webhook: {webhook_url}")
    while True:
        try:
            response = requests.post(webhook_url, json={'task_id': task_id}, timeout=3600)
            if response.status_code == 200:
                data = response.json()
                status = data.get('status')
                print(f"[{task_id}] Webhook response status: {status}")
                if status in ['completed', 'error']:
                    print(f"[{task_id}] Task finished with status: {status}")
                    break
                elif status == 'waiting_input':
                    # Task needs user input. Wait a bit before polling again.
                    # The Laravel backend should return immediately if it's still waiting.
                    time.sleep(5)
                else:
                    # If it returned 'processing' or 'pending', maybe it was just a heartbeat or chunk
                    time.sleep(2)
            else:
                print(f"[{task_id}] Webhook error {response.status_code}: {response.text}")
                time.sleep(5)
        except Exception as e:
            print(f"[{task_id}] Request exception: {e}")
            time.sleep(5)
    print(f"[{task_id}] Thread finished.")

@app.route('/process-task', methods=['POST'])
def process_task():
    data = request.json
    task_id = data.get('task_id')
    webhook_url = data.get('webhook_url')

    if not task_id or not webhook_url:
        return jsonify({'error': 'task_id and webhook_url required'}), 400

    thread = threading.Thread(target=run_task, args=(task_id, webhook_url))
    thread.daemon = True
    thread.start()

    return jsonify({'message': 'Task processing initiated', 'task_id': task_id}), 200

if __name__ == '__main__':
    port = int(os.environ.get('PORT', 5002))
    app.run(host='0.0.0.0', port=port)

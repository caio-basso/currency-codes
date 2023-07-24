import json
import sys
from flask import Flask
from werkzeug.exceptions import HTTPException
from TableSpider import TableSpider
import subprocess
import os

app = Flask(__name__)

@app.route('/',  methods=['GET'])
def get_currency_data():
    try:
        subprocess.run(["scrapy", "runspider", "TableSpider.py", "-O", "data.json"])
        json_file_path = os.path.join(os.path.dirname(__file__), 'data.json')

        with open(json_file_path, 'r') as file:
            data = file.read()

        return app.response_class(
            response=data,
            status=200,
            mimetype='application/json'
        )
    except Exception as exception:
        error_payload = generate_exception_info(exception)

        return app.response_class(
            response=json.dumps(error_payload),
            status=error_payload.get('code'),
            mimetype='application/json'
        )

def generate_exception_info(exception):
    exception_type, exception_object, exception_traceback = sys.exc_info()
    filename = exception_traceback.tb_frame.f_code.co_filename
    line_number = exception_traceback.tb_lineno
    exception_code = 500

    if isinstance(exception, HTTPException):
        exception_code = exception.code

    return {
        'error': str(exception),
        'filename': filename,
        'line_number': line_number,
        'exception_type': str(exception_type),
        'code': exception_code
    }


if __name__ == "__main__":
    app.run(host="0.0.0.0", debug=True)
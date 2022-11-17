FROM python:3.11-alpine as dev

RUN adduser -D pyuser

USER pyuser

COPY ./src /app

WORKDIR /app

RUN pip install -r requirements.txt

ENTRYPOINT ["python", "new_task.py"]
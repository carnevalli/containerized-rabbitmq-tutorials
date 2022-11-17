FROM python:3.9.6-alpine3.13 as dev

COPY ./src/ /app 

RUN adduser -D pyuser

USER pyuser

WORKDIR /app

RUN pip install -r requirements.txt

ENTRYPOINT [ "python", "/app/sender.py" ]
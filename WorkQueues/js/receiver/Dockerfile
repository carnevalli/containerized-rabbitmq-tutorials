FROM node:19-alpine

COPY ./src/package.json /app/package.json

WORKDIR /app

RUN npm install

COPY ./src /app

ENTRYPOINT ["node", "worker.js"]
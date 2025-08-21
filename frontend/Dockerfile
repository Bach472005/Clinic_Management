FROM node:20-alpine

WORKDIR /app

COPY package*.json ./

RUN npm cache clean --force && npm install

COPY . .

ENV ROLLUP_IGNORE_NATIVE=1

RUN npm run build

FROM node:14-alpine

RUN apk --no-cache add pkgconfig autoconf automake libtool nasm build-base zlib-dev libpng-dev git

WORKDIR /app

COPY package.json /app

RUN yarn install

COPY . /app

EXPOSE 3000

CMD ["yarn","serve"]

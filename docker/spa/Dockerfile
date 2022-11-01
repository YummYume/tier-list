FROM node:lts-alpine3.16

WORKDIR /usr/src/spa

COPY ./spa/package.json ./

RUN yarn install

CMD ["yarn", "dev"]

FROM node:lts-alpine3.16

WORKDIR /usr/src/spa

COPY ./spa/package.json ./spa/yarn.lock ./

RUN yarn install

CMD ["yarn", "dev"]

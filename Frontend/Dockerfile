FROM node:10 as builder

#TODO
#ENV NODE_ENV production

RUN mkdir -p /home/node/app
WORKDIR /home/node/app

RUN chown -R node:node /home/node/app

USER node

COPY package.json package-lock.json /home/node/app/
RUN npm install

COPY . /home/node/app/
RUN npm run ssr:build

###
FROM node:10-alpine

ENV NODE_ENV production
ENV HOST 0.0.0.0
ENV PORT 8080
EXPOSE 8080

USER node
WORKDIR /home/node/app

COPY --chown=node:node --from=builder /home/node/app /home/node/app

CMD ["npm", "run", "ssr:start"]

FROM golang:1.19-alpine as build

COPY ./src/go.mod /app/
WORKDIR /app
COPY ./src /app
RUN go build -o app

FROM alpine:3.16 as runtime
COPY --from=build /app/app /
ENTRYPOINT ["./app"]
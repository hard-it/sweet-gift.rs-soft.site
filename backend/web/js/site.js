function roundMoney(cost, decWidth) {
  return Math.round((cost + Number.EPSILON) * (Math.pow(10, decWidth)) / Math.pow(10, decWidth));
}

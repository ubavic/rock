const monthNames = ['Јануар', 'Фебруар', 'Март',
    'Април', 'Мај', 'Јун',
    'Јул', 'Август', 'Септембар',
    'Октобар', 'Новембар', 'Децембар'];

const svg = d3.select('#heatmap')
const svg2 = d3.select('#bars')
const side = 20
const margin = 3
const width = parseInt(svg.style("width"))
const width2 = parseInt(svg.style("width"))
const weeks = Math.floor((width - 10)/(side + margin)) 

let days = []
let monthLabels = []
let selected = -1

svg.attr('height', 180)

const heatmap = svg.append('g')

const today = new Date()
const dayOfWeek = today.getDay()

let date = new Date()
date.setHours(1, 0, 0, 0)

for (let i = 6 - dayOfWeek; Math.floor(i / 7) < weeks -1; i++) {
    days.push({
        index: i,
        week: Math.floor(i / 7),
        day: (date.getDay()) % 7,
        hits: 0,
        date: new Date(date.getTime())
    })

    if (date.getDate() === 1 && i > 6) {
        monthLabels.push({
            week: Math.floor(i / 7),
            label: monthNames[date.getMonth()].slice(0,3)
        })
    }

    date.setDate(date.getDate()-1);
}

const toggleDay = day => {
    selected = (day.index === selected) ? -1 : day.index;

    if (selected > -1) {
        setSubtitle(day)
        getStatisticsForDate(day.date)
    } else {
        setSubtitle(null)
        svg2.selectAll('a').remove()
    }
}

const color = ({index, hits}) => {
    if (index == selected)
        return `hsl(360, 50%, 50%)`

    const l = ((1 - hits)/3 + 0.5) * 100
    const s = 2*Math.sqrt(hits)/3 * 100

    return `hsl(200, ${s}%, ${l}%)`
}

const setSubtitle = day => {
    if (day === null) {
        const svg = d3.select('#bars')
        svg.selectAll('g').remove()
        return d3.select('h3').text(`.`)
    }

    let date = `${day.date.getDate()}. ${monthNames[day.date.getMonth()]}`
    d3.select('h3').text(`${date}`)
}

const drawExamStatistics = exams => {
    svg2.selectAll('a')
        .remove()

    let groups = svg2.selectAll('a')
        .data(exams)
        .enter()
        .append('a')
        .attr('href', (e, i) => `/exam/${e[i].subject}`)

    groups.append('rect')
        .attr('x', margin)
        .attr('y', (_, i) => i * (side + margin))
        .attr('width', d => 0.9 * d.width * width2)
        .attr('height', side)
        .attr('fill', '#93bed3')
        .attr('rx', 2)

    groups.append('text')
        .text((d, i) => `${d[i].name} (${d[i].hits})`)
        .attr('x', 2 * margin)
        .attr('y', (_, i) => i * (side + margin) + 16)
}

const getStatisticsForDate = date => {
    const day = date.getDate()
    const month = date.getMonth() + 1
    const year = date.getFullYear() % 2000

    return fetch(`/cp/getStatistics/${day}-${month}-${year}`)
        .then(j =>  j.json())
        .then(exams => {
            const max = Math.max(...exams.map(o => o.hits))
            drawExamStatistics(exams.map(e => ({...exams, width: e.hits/max})))
        })
}

const drawHeatmap = () => {
    heatmap.selectAll('rect')
    .remove()

    heatmap.selectAll('rect')
    .data(days)
    .enter()
    .append('rect')
    .attr('x', d =>  (side + margin) * (weeks - d.week - 1))
    .attr('y', d => (side + margin) * d.day + 2)
    .attr('width', side)
    .attr('height', side)
    .attr('fill', color)
    .attr('rx', 2)
    .attr('style', 'cursor: pointer')
    .on('click', (_, d) => {
        toggleDay(d)
        drawHeatmap()
    })
    .attr('class', 'square')
}

const drawAxis = () => {
    const xAxis = svg.append('g')
    const yAxis = svg.append('g')

    yAxis.selectAll('text')
        .data(['П', 'У', 'С', 'Ч', 'П', 'С', 'Н'])
        .enter()
        .append('text')
        .attr('x', 0)
        .attr('y', (_, i) =>  (side + margin) * (i + 1) - 4)
        .text(d => d)
        .attr('color', 'black')

    xAxis.selectAll('text')
        .data(monthLabels)
        .enter()
        .append('text')
        .attr('x', d => (side + margin) * (weeks - d.week - 1) + 5)
        .attr('y', 7 * (side + margin) + 15)
        .text(d => d.label)
        .attr('color', 'black')
}

fetch('/cp/getStatistics').then(j =>  j.json()).then(js => {
    const day = 24 * 60 * 60 * 1000
    const max = Math.max(...js.map(o => o.hits))

    for (let m in js) {
        const date = new Date(js[m].date)
        const i = Math.floor((today - date) / day)
        days[i].hits = js[m].hits/max
    }
    drawHeatmap()
    drawAxis()
})
